FROM nginx:stable-alpine-slim

# Install certbot
RUN apk add --no-cache certbot certbot-nginx

# Copy nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf
COPY conf.d/ /etc/nginx/conf.d/

# Create directory for Let's Encrypt certificates
RUN mkdir -p /etc/letsencrypt

# Copy SSL renewal script
COPY ssl-renew.sh /etc/periodic/weekly/ssl-renew
RUN chmod +x /etc/periodic/weekly/ssl-renew

EXPOSE 80 443 