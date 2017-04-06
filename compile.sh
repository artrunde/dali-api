#!/usr/bin/env bash
sudo su
yum install -y libexif-devel libjpeg-devel gd-devel curl-devel openssl-devel libxml2-devel gcc
cd /tmp
wget http://de1.php.net/get/php-7.0.16.tar.gz/from/this/mirror -O php-7.0.16.tar.gz
tar zxvf php-7.0.16.tar.gz
cd php-7.0.16
./configure --prefix=/tmp/php-7.0.16/compiled/ --disable-all --without-pear --enable-shared=no --enable-static=yes --enable-phar --enable-json --with-openssl --with-curl --enable-libxml --enable-simplexml --enable-xml --with-mhash --enable-exif --enable-mbstring --enable-sockets --enable-pdo --with-pdo-mysql --enable-tokenizer --enable-mbstring --with-gd --enable-gd-native-ttf --with-freetype-dir --with-jpeg-dir --with-png-dir --enable-ctype --enable-filter
make
make install

#!/usr/bin/env bash
sudo yum install -y git gcc gcc-c++ libxml2-devel pkgconfig openssl-devel bzip2-devel curl-devel libpng-devel libjpeg-devel libXpm-devel freetype-devel gmp-devel libmcrypt-devel mariadb-devel aspell-devel recode-devel autoconf bison re2c libicu-devel git

cd /tmp
wget http://de1.php.net/get/php-7.1.2.tar.gz/from/this/mirror -O php-7.1.2.tar.gz
tar zxvf php-7.1.2.tar.gz
cd php-7.1.2

git clone https://github.com/php/php-src.git
cd php-src/
git checkout PHP-7.1.2

./buildconf --force

./configure --prefix=/tmp/php-7.1.2/compiled/  --disable-all --without-pear --enable-shared=no --enable-static=yes --enable-phar --enable-json --with-openssl --with-curl --enable-libxml --enable-simplexml --enable-xml --with-mhash --enable-exif --enable-mbstring --enable-sockets --enable-pdo --with-pdo-mysql --enable-tokenizer --enable-mbstring --with-gd --enable-gd-native-ttf --with-freetype-dir --with-jpeg-dir --with-png-dir --enable-ctype --enable-filter
	
make
make install

cd /tmp
https://github.com/phalcon/zephir
cd zephir/
./install -c

cd /tmp
git clone https://github.com/phalcon/cphalcon
cd cphalcon/

