#!/bin/sh

git filter-branch --env-filter --force '

OLD_EMAIL="27856297+dependabot-preview[bot]@users.noreply.github.com"
CORRECT_NAME="Yogi"
CORRECT_EMAIL="me@yogi.codes"

if [ "$GIT_COMMITTER_EMAIL" = "$OLD_EMAIL" ]
then
export GIT_COMMITTER_NAME="$CORRECT_NAME"
export GIT_COMMITTER_EMAIL="$CORRECT_EMAIL"
fi
if [ "$GIT_AUTHOR_EMAIL" = "$OLD_EMAIL" ]
then
export GIT_AUTHOR_NAME="$CORRECT_NAME"
export GIT_AUTHOR_EMAIL="$CORRECT_EMAIL"
fi
' --tag-name-filter cat -- --branches --tags