ARG TARGETPLATFORM
ARG BUILDPLATFORM
FROM --platform=${TARGETPLATFORM:-linux/amd64} ghcr.io/openfaas/of-watchdog:0.8.4 as watchdog
FROM --platform=${TARGETPLATFORM:-linux/amd64} composer:2 as dependencyInstaller

# Install core dependencies
WORKDIR /app
COPY ../.. .
RUN composer i -o --no-dev --ignore-platform-reqs --prefer-dist --no-progress --no-scripts

# Install function dependencies
WORKDIR /app/function
RUN composer i -o --no-dev --ignore-platform-reqs --prefer-dist --no-progress --no-scripts

FROM --platform=${TARGETPLATFORM:-linux/amd64} php:8.0.10-cli-alpine3.14

RUN chmod 777 /tmp

# Create a non-root user
RUN apk --no-cache add curl ca-certificates \
    && addgroup -S app && adduser -S -g app app

# Copy watchdog
COPY --from=watchdog /fwatchdog /usr/bin/fwatchdog
RUN chmod +x /usr/bin/fwatchdog

# Copy the app with installed dependencies
WORKDIR /home/app
COPY --from=dependencyInstaller /app /home/app
RUN chown app:app -R /home/app

# Install php extensions
RUN [[ -f php-extension.sh ]] && sh ./php-extension.sh && \
    chown -R app /home/app

USER app

ENV cgi_headers="true"
ENV fprocess="php -S 0.0.0.0:8000 index.php"
ENV mode="http"
ENV upstream_url="http://127.0.0.1:8000"

EXPOSE 8080

HEALTHCHECK --interval=3s CMD [ -e /tmp/.lock ] || exit 1

CMD ["fwatchdog"]
