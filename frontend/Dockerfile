FROM node:10.15.3-stretch-slim

RUN apt-get update && apt-get install -y perl-modules

RUN deluser --remove-home node \
  && addgroup --system node --gid 1000 \
  && adduser --system --gid 1000 --uid 1000 node

ENV APP_ROOT /app

RUN mkdir ${APP_ROOT}
WORKDIR ${APP_ROOT}
ADD . ${APP_ROOT}

RUN rm -rf node_modules
RUN npm install -g npm@6.10.1
RUN chown -R node:node /app

USER node

RUN npm install
RUN npm run build

ENV HOST 0.0.0.0
