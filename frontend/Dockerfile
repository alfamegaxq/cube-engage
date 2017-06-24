FROM node:6.11

RUN mkdir -p /usr/src/app
RUN mkdir -p /worker
COPY ./package.json /worker

RUN cd /worker && npm install -g @angular/cli && npm isntall gulp-cli -g && npm install gulp -D &&  ls -la && npm install
WORKDIR /usr/src/app

EXPOSE 4200
CMD cp -Rf /worker/node_modules /usr/src/app/node_modules && ng serve --host 0.0.0.0
