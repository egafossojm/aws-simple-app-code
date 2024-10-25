
<div class="col-sm-6 col-md-12 micro-module sponsor-bg">
    <div class="row">
        <div class="bloc events-widget">
            <div class="row head">
                <div class="col-md-12">
                    <h2>Careers</h2>
                </div>
            </div>
            <ul class="row">
                <li class="col-sm-12">
                    <div class="text-center">
<?php
$repeater = get_field('acf_job_posting_widget_jobs', 'option');
foreach ($repeater as $key => $value) {
    echo "<a href=\"{$value['url']}\"><h3>{$value['title']}</h3></a>";
}
?>
                        <a class="btn btn-footer btn-events" href="<?php echo get_field('acf_job_posting_widget_page_bencan_link', 'option'); ?>">
                            <span>Post a job</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

