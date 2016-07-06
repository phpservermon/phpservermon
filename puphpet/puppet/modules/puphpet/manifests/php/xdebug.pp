class puphpet::php::xdebug (
  $install_cli = true,
  $webserver,
  $compile     = false,
  $ensure      = present
) inherits puphpet::params {

  if $webserver != undef {
    $notify_service = Service[$webserver]
  } else {
    $notify_service = []
  }

  if !$compile and ! defined(Package[$puphpet::params::xdebug_package]) {
    package { 'xdebug':
      name    => $puphpet::params::xdebug_package,
      ensure  => installed,
      require => Package['php'],
      notify  => $notify_service,
    }
  } else {
    # php 5.6 requires xdebug be compiled, for now
    case $::operatingsystem {
      'debian': {$mod_dir = '/usr/lib/php5/20131226-zts'}
      'ubuntu': {$mod_dir = '/usr/lib/php5/20131226'}
      'redhat', 'centos': {$mod_dir = '/usr/lib64/php/modules'}
    }

    exec { 'git clone https://github.com/xdebug/xdebug.git /.puphpet-stuff/xdebug':
      creates => '/.puphpet-stuff/xdebug',
      require => Class['Php::Devel'],
    }
    -> exec { 'phpize && ./configure --enable-xdebug && make':
      creates => '/.puphpet-stuff/xdebug/configure',
      cwd     => '/.puphpet-stuff/xdebug',
    }
    -> exec { "cp /.puphpet-stuff/xdebug/modules/xdebug.so ${mod_dir}":
      creates => "${mod_dir}/xdebug.so",
    }

    puphpet::php::ini { 'xdebug/zend_extension':
      entry       => "XDEBUG/zend_extension",
      value       => "${mod_dir}/xdebug.so",
      php_version => '5.6',
      webserver   => $webserver,
      require     => Exec["cp /.puphpet-stuff/xdebug/modules/xdebug.so ${mod_dir}"],
    }
  }

  # shortcut for xdebug CLI debugging
  if $install_cli and defined(File['/usr/bin/xdebug']) == false {
    file { '/usr/bin/xdebug':
      ensure  => present,
      mode    => '+X',
      source  => 'puppet:///modules/puphpet/xdebug_cli_alias.erb',
      require => Package['php']
    }
  }

}
