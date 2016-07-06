define monitor::url (
  $tool,
  $url          = 'http://127.0.0.1',
  $target       = '',
  $host         = '',
  $port         = '80',
  $pattern      = '',
  $username     = '',
  $password     = '',
  $monitorgroup = '',
  $template     = '',
  $useragent    = 'UrlCheck',
  $checksource  = 'remote',
  $enable       = true
  ) {

  $bool_enable=any2bool($enable)

  $ensure = $bool_enable ? {
    false => 'absent',
    true  => 'present',
  }

  # If target is not provided we get it from the Url
  $computed_target = $target ? {
    ''      => url_parse($url,host),
    default => $target,
  }

  # If host is not provided we get it from the Url
  $computed_host = $host ? {
    ''      => url_parse($url,host),
    default => $host,
  }

  # Manage template
  $real_template = $template ? {
    ''      => undef,
    default => $template,
  }

  # Needed to create flag todo files seamlessly
  $urlq = regsubst($url , '/' , '-' , 'G')

  if ($tool =~ /munin/) {
  }

  if ($tool =~ /collectd/) {
  }

  if ($tool =~ /monit/) {
  }

  $local_check_command = $username ? { # CHECK VIA NRPE STILL DOESN'T WORK WITH & and ? in URLS!
    undef   => "check_nrpe!check_url!${computed_target}!${port}!${url}!${pattern}!${useragent}!${computed_host}" ,
    ''      => "check_nrpe!check_url!${computed_target}!${port}!${url}!${pattern}!${useragent}!${computed_host}" ,
    default => "check_nrpe!check_url_auth!${computed_target}!${port}!${url}!${pattern}!${username}:${password}!${useragent}!${computed_host}" ,
  }

  $default_check_command = $username ? {
    undef   => "check_url!${computed_target}!${port}!${url}!${pattern}!${useragent}" ,
    ''      => "check_url!${computed_target}!${port}!${url}!${pattern}!${useragent}" ,
    default => "check_url_auth!${computed_target}!${port}!${url}!${pattern}!${username}:${password}!${useragent}" ,
  }

  $check_command = $checksource ? {
    local   => $local_check_command,
    default => $default_check_command
  }

  if ($tool =~ /nagios/) {
    # Use for Example42 service checks
    # (note: are used custom Nagios and nrpe commands)
    nagios::service { $name:
      ensure        => $ensure,
      template      => $real_template,
      check_command => $check_command,
    }
  }

  if ($tool =~ /icinga/) {
    icinga::service { $name:
      ensure        => $ensure,
      template      => $real_template,
      check_command => $check_command,
    }
  }

  $puppi_hostwide = $monitorgroup ? {
    undef   => 'yes' ,
    ''      => 'yes' ,
    default => 'no' ,
  }

  $puppi_command = $username ? {
    undef   => "check_http -I '${computed_target}' -p '${port}' -u '${url}' -H '${computed_host}' -r '${pattern}' -A '${useragent}'" ,
    ''      => "check_http -I '${computed_target}' -p '${port}' -u '${url}' -H '${computed_host}' -r '${pattern}' -A '${useragent}'" ,
    default => "check_http -I '${computed_target}' -p '${port}' -u '${url}' -H '${computed_host}' -r '${pattern}' -a ${username}:${password} -A '${useragent}'" ,
  }

  if ($tool =~ /puppi/) {
    # Use for Example42 puppi checks
    puppi::check { $name:
      enable   => $enable,
      hostwide => $puppi_hostwide,
      project  => $monitorgroup ,
      command  => $puppi_command,
    }
  }
}
