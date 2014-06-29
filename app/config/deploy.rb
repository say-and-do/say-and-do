set :application, "darau"
set :domain,      "188.226.251.241"
set :deploy_to,   "/var/www/#{application}.lt"
set :app_path,    "bin"
set :user,        "root"

set :repository,  "git@github.com:say-and-do/say-and-do.git"
set :scm,         :git

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
set :use_composer, true
set :symfony_console, "bin/console"
set :cache_path,            "var/cache"
set :log_path,              "var/logs"

set  :keep_releases,  3
set :use_sudo, false
set :writable_dirs,       ["var/cache", "var/logs"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
