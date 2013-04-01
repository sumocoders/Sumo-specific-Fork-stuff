# Sumo specific Fork stuff

Fork CMS is great, we use it all the time for client-projects. But we also
like our internal tools.

So this codebase will tie in our internal tools into Fork CMS for the sites we
create for our clients.

## Errbit

At SumoCoders we use Errbit to track errors in a project. So instead of using
the default errorhandlers of Fork (where errors will be mailed) we use our own
errorhandlers who send errors to our Errbit instance.

Also we output an error messages in the well known Sumo-style.