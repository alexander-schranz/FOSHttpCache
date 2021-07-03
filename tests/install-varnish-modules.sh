#!/bin/sh

set -e

echo "### Installing Varnish Modules ${VARNISH_MODULES_VERSION} ###"
sudo apt-get install varnish-dev

curl -A "FOS Github" -o /tmp/varnish-modules.tar.gz -D - -L -s https://github.com/varnish/varnish-modules/archive/refs/tags/${VARNISH_MODULES_VERSION}.tar.gz
tar zxpf /tmp/varnish-modules.tar.gz -C /tmp/
cd /tmp/varnish-modules-${VARNISH_MODULES_VERSION}
./configure
make
# make check
sudo make install
rm -f /tmp/varnish-modules.tar.gz && rm -Rf /tmp/varnish-modules
