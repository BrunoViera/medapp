# docker build -t medapp-node docker/node/ --no-cache
# docker run -it -v $(pwd):/home/app medapp-node bash
# docker run -it -v $(pwd):/home/app medapp-node npm install
FROM node:8

RUN npm install gulp-cli -g

WORKDIR /home/app
