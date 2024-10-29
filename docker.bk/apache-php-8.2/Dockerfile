FROM httpd:latest

# Define VERSION as a build argument
ARG VERSION

# Set the environment variable DIR using the build argument
ENV DIR=${VERSION}

# Create the directory using the environment variable
RUN mkdir ${DIR}

