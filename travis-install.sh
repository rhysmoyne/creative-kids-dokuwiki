#!/bin/sh
git submodule init && \
git config user.name "Rhys Moyne" && \
git config user.email "rhys@creativekidssa.com.au" && \
git submodule update && \
git submodule update --remote data/pages && \
git add data/pages && \
git commit -m "Update wiki to latest content."; \
git push -u origin master && \
echo 0
