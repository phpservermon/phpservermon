# Package dependencies for Passenger on RedHat
class rvm::passenger::dependencies::centos {

  $version = $::operatingsystem ? {
    'Amazon' => '6.x',
    default  => $::operatingsystemrelease,
  }

  case $version {
    /^6\..*/: {
      ensure_packages(['libcurl-devel'])
    }
    default: {
      ensure_packages(['curl-devel'])
    }
  }
}
