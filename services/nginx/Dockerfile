FROM nginx:latest
# The default nginx.conf DOES NOT include /etc/nginx/sites-enabled/*.conf

COPY nginx.conf /etc/nginx/
COPY sites-available/* /etc/nginx/sites-available/

RUN echo "upstream php-upstream { server php:9000; } " > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

# Solves 1
RUN mkdir -p /etc/nginx/sites-enabled/ \
    && ln -s /etc/nginx/sites-available/* /etc/nginx/sites-enabled

# Solves 2
RUN usermod -u 1000 www-data
CMD ["nginx"]
EXPOSE 80