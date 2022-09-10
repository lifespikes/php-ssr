#!/bin/zsh

# BuildTools and Install PHP-V8 Extension, only for Mac OS X

# First install V8
brew install v8

# Then build PHP-V8
cd /tmp || exit
git clone https://github.com/phpv8/v8js.git
cd v8js || exit
phpize
./configure --with-v8js=/opt/homebrew CPPFLAGS="-DV8_COMPRESS_POINTERS"
make -j4
make test
make install
