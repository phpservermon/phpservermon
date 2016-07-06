# Configure the /etc/rvmrc file
class rvm::rvmrc(
  $template = 'rvm/rvmrc.erb',
  $umask = 'u=rwx,g=rwx,o=rx',
  $max_time_flag = undef,
  $autoupdate_flag = '0',
  $silence_path_mismatch_check_flag = undef) inherits rvm::params {

  include rvm::group

  file { '/etc/rvmrc':
    content => template($template),
    mode    => '0664',
    owner   => 'root',
    group   => $rvm::params::group,
    before  => Exec['system-rvm'],
  }
}
