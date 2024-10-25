<?php

class DialogInsight
{
    private static $idProject;

    private static $idKey;

    private static $key;

    private static $aSetup;

    const URL_API = 'https://ofsys.com/webservices/ofc4';

    const URL_Contact = '/contacts.ashx?method=Merge';

    const URL_Contact_Data = '/contacts.ashx?method=Get';

    const URL_Sending = '/sendings.ashx?method=SendBatch';

    const URL_Message = '/messages.ashx?method=Create';

    public function __construct()
    {

        self::$idProject = AVATAR_DIALOG_INSIGHT_PROJECT_ID;
        self::$idKey = AVATAR_DIALOG_INSIGHT_KEY_ID;
        self::$key = AVATAR_DIALOG_INSIGHT_KEY;
        self::$aSetup = [
            'AuthKey' => [
                'idKey' => self::$idKey,
                'Key' => self::$key,
            ],
            'idProject' => self::$idProject,
        ];
    }

    /**
     * Description : Construire la requete Contact Merge
     **/
    public function getContact_Merge_Json($aRecordsSubscriptions, $method = 'Insert')
    {

        $return['headers'] = ['Content-Type: application/json'];
        $return['json'] = array_merge(self::$aSetup, $aRecordsSubscriptions);
        $aMergeOptions = ['MergeOptions' => [
            'AllowInsert' => (strstr($method, 'Insert') ? true : false),
            'AllowUpdate' => true,
            'SkipDuplicateRecords' => false,
            'SkipUnmatchedRecords' => false,
            'ReturnRecordsOnSuccess' => true,
            'ReturnRecordsOnError' => false,
            'FieldOptions' => null,
        ],
        ];

        $return['json'] = array_merge($return['json'], $aMergeOptions);
        $return['CURLOPT_URL'] = self::URL_Contact;

        return $return;
    }

    /**
     * Description : Construire la requete get Contact Data
     **/
    public function getContact_Data_Json($email, $method = 'Get')
    {
        $json_request['headers'] = ['Content-Type: application/json'];
        $aClause['Clause'] = [
            '$type' => 'FieldClause',
            'Field' => ['Name' => 'f_EMail'],
            'TypeOperator' => 'Equal',
            'ComparisonValue' => $email,
        ];
        $json_request['json'] = array_merge(self::$aSetup, $aClause);
        $json_request['CURLOPT_URL'] = self::URL_Contact_Data;

        $di_response = $this->doDiExecute($json_request);

        return new DIProfile($di_response);
    }

    /**
     * @param  type  $messageRecord
     *                               Description: construire la requête Create message
     */
    public function getCreateMessage_Json($messageRecord)
    {
        $return['headers'] = ['Content-Type: application/json'];
        $return['json'] = array_merge(self::$aSetup, $messageRecord);
        $return['CURLOPT_URL'] = self::URL_Message;
        $result = $this->doDiExecute($return);

        return $result->idMessage;
    }

    /**
     * @param  type  $idMessage
     *                           Description: construire la requête Send Message
     */
    public function getSendMessage_Json($idMessage, $sending_date, $clauses = 'All')
    {
        $return['headers'] = ['Content-Type: application/json'];

        switch ($clauses) {
            case 'All':
                $contactFilter = ['Mode' => 'All'];
                $aSendOptions = ['sendBatchOptions' => [
                    'isDelayed' => true,
                    'dtLaunch' => date('Y.m.d H:i:s', strtotime($sending_date)),
                    'PrepareNow' => true,
                    'AutoApprove' => true],
                ];
                break;

            default:
                $contactFilter = [
                    'Mode' => 'idFilters',
                    'idFilters' => [0 => intval($clauses)],
                ];
                $aSendOptions = ['sendBatchOptions' => [
                    'isDelayed' => false,
                    'PrepareNow' => true,
                    'AutoApprove' => true],
                ];
                break;
        }

        $return['json'] = array_merge(self::$aSetup, [
            'idMessage' => $idMessage,
            'contactFilter' => $contactFilter,
        ]
        );

        $return['json'] = array_merge($return['json'], $aSendOptions);
        $return['CURLOPT_URL'] = self::URL_Sending;
        $result = $this->doDiExecute($return);

        return $result;
    }

    /**
     * @param  type  $aJsonCall
     *
     * @throws Exception
     */
    public function callWebService($aJsonCall)
    {

        $curlopt_url = self::URL_API.$aJsonCall['CURLOPT_URL'];
        $jsonStr = json_encode($aJsonCall['json']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curlopt_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Content-Length: '.strlen($jsonStr),
        ]
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);

        if (curl_errno($ch) !== CURLE_OK) {
            throw new Exception('CURL error: '.curl_error($ch));
        }
        curl_close($ch);

        return $this->parseJSON($data);

    }

    public function parseJSON($data)
    {

        $result = json_decode($data);
        // var_dump($result );

        if (! $result->Success) {
            throw new Exception($result->ErrorMessage);
        }

        return $result;
    }

    /**
     * Description : Call the WS
     **/
    final protected function doDiExecute($jsonData)
    {

        $result = false;
        try {
            $result = $this->callWebService($jsonData);
        } catch (Exception $e) {
            //array_push($this->errorLogArray, 'Service Error : '.$e) ;
            echo $e;
        }

        // to DO get result
        return $result;
    }
}
