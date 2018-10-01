# docker build -t medapp-node --no-cache
# docker run -it -v $(pwd):/ medapp-node bash
# docker run -it -v $(pwd):/ medapp-node npm install
FROM node:8

RUN npm install gulp-cli -g

WORKDIR /