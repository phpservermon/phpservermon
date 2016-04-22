# Install the RVM system
class rvm::system(
  $version=undef,
  $proxy_url=undef) {

  class {'rvm::gpg':}

  $actual_version = $version ? {
    undef     => 'latest',
    'present' => 'latest',
    default   => $version,
  }

  # curl needs to be installed
  if ! defined(Package['curl']) {
    case $::kernel {
      'Linux': {
        ensure_packages(['curl'])
        Package['curl'] -> Exec['system-rvm']
      }
      default: {}
    }
  }

  $proxy_environment = $proxy_url ? {
    undef   => undef,
    default => [ "http_proxy=${proxy_url}" , "https_proxy=${proxy_url}" ],
  }

  exec { 'system-rvm-gpg-key':
    command     => 'gpg2 --keyserver hkp://keys.gnupg.net --recv-keys D39DC0E3',
    path        => $::path,
    environment => 'HOME=/root',
    unless      => 'gpg2 --list-keys D39DC0E3',
    require     => Class['::rvm::gpg']
  } ->

  exec { 'system-rvm':
    path        => '/usr/bin:/usr/sbin:/bin',
    command     => "/usr/bin/curl -fsSL https://get.rvm.io | bash -s -- --version ${actual_version}",
    creates     => '/usr/local/rvm/bin/rvm',
    environment => $proxy_environment,
  }

  # the fact won't work until rvm is installed before puppet starts
  if !empty($::rvm_version) {
    if ($version != undef) and ($version != present) and ($version != $::rvm_version) {
      # Update the rvm installation to the version specified
      notify { 'rvm-get_version':
        message => "RVM updating from version ${::rvm_version} to ${version}",
      }
      exec { 'system-rvm-get':
        path        => '/usr/local/rvm/bin:/usr/bin:/usr/sbin:/bin',
        command     => "rvm get ${version}",
        before      => Exec['system-rvm'], # so it doesn't run after being installed the first time
        environment => $proxy_environment,
        require     => Notify['rvm-get_version'],
      }
    }
  }
}
