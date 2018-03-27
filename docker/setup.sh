#!/bin/bash

IMAGE='dbc_image'
CONTAINER='dbc_container'

DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

docker build \
    -t "$IMAGE" \
    --build-arg UID=`id -u` \
    "$DIR"

docker rm -f "$CONTAINER"

docker run \
--net=host \
-d \
-v "$DIR"/../../:/home/audiens/projects \
--volume /home/"${USER}"/.composer/:/home/audiens/.composer \
--privileged \
--name "$CONTAINER" \
-ti "$IMAGE" tail -f /dev/null

sleep 1

docker exec -ti -u audiens "$CONTAINER" bash
