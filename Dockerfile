FROM outlawstar4761/rpi-raspbian-apache-php
ENV TZ=America/Chicago
ADD ./ /var/www/html
RUN apt-get update && apt-get install cron -y
RUN chmod -R 0755 /var/www/html
RUN rm /var/www/html/index.html
RUN chmod +x /var/www/html/Libs/ContainerSetup/webContainerSetup.sh
RUN chmod +x /var/www/html/Libs/cronClientSetup/cronWrapperSetup.sh
RUN /var/www/html/Libs/ContainerSetup/webContainerSetup.sh /mnt/LOE/log/webaccess.access.log
RUN /var/www/html/Libs/cronClientSetup/cronWrapperSetup.sh
RUN mv /var/www/html/creds /opt/scripts/
RUN crontab < /var/www/html/Libs/AccessLogParser/crontab
RUN service cron start
EXPOSE 443
CMD ["/run.sh"]
