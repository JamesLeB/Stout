General Setup
<ul>
	<li>$ sudo apt-get install ssh</li>
	<li>$ sudo apt-get install vim</li>
	<li>configure vim</li>
	<li>$ sudo apt-get install git</li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
</ul>
LAMP Setup
<ul>
	<li>$ sudo apt-get install apache2</li>
	<li>$ sudo apt-get install php5</li>
	<li>$ sudo apt-get install php5-dev</li>
	<li>Install Freetds</li>
	<li>$ ./configure --enable-msdblib --prefix=/usr/local/freetds</li>
	<li>$ make</li>
	<li>$ sudo make install</li>
	<li>$ sudo touch /usr/local/freetds/include/tds.h</li>
	<li>$ sudo touch /usr/local/freetds/lib/libtds.a</li>
	<li>Create php Extention</li>
	<li>Go to php*/ext/mssql</li>
	<li>$ phpize</li>
	<li>$ ./configure --with-mssql=/usr/local/freetds</li>
	<li>$ make</li>
	<li>Install the extension</li>
	<li>$ php -i | grep extension_dir</li>
	<li>$ sudo cp modules/mssql.so /usr/lib/php5/*+lfs</li>
	<li>Add extension=mssql.so to /etc/php5/apache2/php.ini</li>
	<li>Configure /usr/local/freetds/etc/freetds.conf</li>
	<li>$ sudo apt-get install mysql-server</li>
	<li>$ sudo apt-get install libapache2-mod-auth-mysql</li>
	<li>$ sudo apt-get install php5-mysql</li>
	<li></li>
</ul>
