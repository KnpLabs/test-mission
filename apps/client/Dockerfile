FROM node:19.8-alpine3.16

WORKDIR /usr/src/app/

ARG VITE_API_URL
ENV VITE_API_URL=${VITE_API_URL}

COPY ./package*.json .

RUN apk add --no-cache \
        g++==11.2.1_git20220219-r2 \
        make==4.3-r0 \
        python3===3.10.10-r0 \
 && yarn install \
 && yarn cache clean

CMD [ "yarn", "run", "dev"]
