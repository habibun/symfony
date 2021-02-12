# install heroku
sudo snap install heroku --classic

# heroku login
heroku login

# create app on heroku
heroku create

# deploy to heroku
git push heroku {branch}

# scale
heroku ps:scale web=1

# open website
heroku open

# View logs
heroku logs --tail

# check how many dynos are running
heroku ps

# interactive PHP shell
heroku run "php -a"

# opens up a shell
heroku run bash

# list add-ons
heroku addons

# attach add-ons
heroku addons:create heroku-postgresql:hobby-dev

# open add-ons
heroku addons:open heroku-postgresql

# config
heroku config:set APP_SECRET=$(php -r 'echo bin2hex(random_bytes(16));')
heroku config:set DATABASE_URL="postgres://zrznwhbilurmoo:89e697150c798d4b7faa8d08e95a775bb89be398881b2c818744bf6bab278c07@ec2-35-174-118-71.compute-1.amazonaws.com:5432/dbpiisd34v6bcb"

# connect to the database
heroku pg:psql

