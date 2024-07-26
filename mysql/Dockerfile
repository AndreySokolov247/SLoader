# Use a base image for MySQL
FROM mysql:latest

# Environment variables for MySQL configuration
ENV MYSQL_ROOT_PASSWORD=password
ENV MYSQL_DATABASE=sloader
ENV MYSQL_USER=sloader
ENV MYSQL_PASSWORD=password

# Copy initialization script to MySQL's entrypoint directory
COPY sloader.sql /docker-entrypoint-initdb.d/

# Expose port
EXPOSE 3306
