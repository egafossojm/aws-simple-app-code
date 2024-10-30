#!/usr/bin/env sh

wp acorn optimize:clear && wp acorn cache:clear --allow-root

# Check if any arguments were provided
if [ $# -gt 0 ]; then
    # If arguments were provided, execute them (could be useful for debugging)
    exec "$@"
else
    # Start supervisord in the foreground
    exec supervisord -c /etc/supervisor/supervisord.conf
fi
