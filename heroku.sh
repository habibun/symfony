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

