FROM node:18

RUN apt-get update \
    && apt-get install -y git \
    && npm install -g http-server

RUN mkdir /www \
    && cd /www \
    && git clone https://github.com/WitalijKaa/test-task.git \
    && cd /www/test-task \
    && git checkout task_anton_1 \
    && cd /www/test-task/frontend \
    && npm install \
    && npm run build

WORKDIR /www/test-task/frontend

EXPOSE 8080

CMD [ "http-server", "dist" ]
