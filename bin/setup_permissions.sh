#!/bin/sh
mkdir -p          app/cache
mkdir -p          app/cache/dev
mkdir -p          app/logs
mkdir -p          web/media/cache
mkdir -p          web/images/uploads
sudo chmod -R +a '_www allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit' app/cache
sudo chmod -R +a '_www allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit' app/logs
sudo chmod -R +a "$USER allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit" app/cache
sudo chmod -R +a "$USER allow read,write,delete,add_file,add_subdirectory,file_inherit,directory_inherit" app/logs
sudo chown -R $USER  *
