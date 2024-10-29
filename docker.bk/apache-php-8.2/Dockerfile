FROM httpd:latest

# Define VERSION as a build argument
ENV VERSION=bookworm

# Set the environment variable DIR using the build argument
ENV DIR=${VERSION}

# Create the directory using the environment variable
RUN mkdir ${DIR}

