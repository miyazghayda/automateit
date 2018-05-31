#!/bin/sh

# Credits: http://stackoverflow.com/a/750191

git filter-branch -f --env-filter "
    GIT_AUTHOR_NAME='miyazghayda'
    GIT_AUTHOR_EMAIL='miyazghayda@gmail.com'
    GIT_COMMITTER_NAME='miyazghayda'
    GIT_COMMITTER_EMAIL='miyazghayda@gmail.com'
  " HEAD
