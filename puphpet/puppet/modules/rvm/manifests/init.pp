# Install RVM, create system user a install system level rubies
class rvm(
  $version=undef,
  $install_rvm=true,
  $install_dependencies=false,
  $system_users=[],
  $system_rubies={},
  $proxy_url=$rvm::params::proxy_url) inherits rvm::params {

  if $install_rvm {

    # rvm has now autolibs enabled by default so let it manage the dependencies
    if $install_dependencies {
      class { 'rvm::dependencies':
        before => Class['rvm::system']
      }
    }

    ensure_resource('class', 'rvm::rvmrc')

    class { 'rvm::system':
      version   => $version,
      proxy_url => $proxy_url,
    }
  }

  rvm::system_user{ $system_users: }
  create_resources('rvm_system_ruby', $system_rubies, {'ensure' => present, 'proxy_url' => $proxy_url})
}
