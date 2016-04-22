require 'spec_helper_acceptance'

osfamily = fact('osfamily')
operatingsystem = fact('operatingsystem')
ruby_package_provider = 'undef'

case osfamily
when 'RedHat'
  java_package   = 'mysql-connector-java'
  perl_package   = 'perl-DBD-MySQL'
  php_package    = 'php-mysql'
  python_package = 'MySQL-python'
  ruby_package   = 'ruby-mysql'
  if fact('operatingsystemmajrelease') == '7'
    ruby_package_provider = 'gem'
  end
when 'Suse'
  java_package   = 'mysql-connector-java'
  perl_package   = 'perl-DBD-mysql'
  php_package    = 'apache2-mod_php53'
  python_package = 'python-mysql'
  case operatingsystem
  when /OpenSuSE/
    ruby_package = 'rubygem-mysql'
  when /(SLES|SLED)/
    ruby_package = 'ruby-mysql'
  end
when 'Debian'
  java_package = 'libmysql-java'
  perl_package     = 'libdbd-mysql-perl'
  php_package      = 'php5-mysql'
  python_package   = 'python-mysqldb'
  if fact('lsbdistcodename') == 'trusty'
    ruby_package   = 'ruby-mysql'
  else
    ruby_package   = 'libmysql-ruby'
  end
when 'FreeBSD'
  java_package = 'databases/mysql-connector-java'
  perl_package   = 'p5-DBD-mysql'
  php_package    = 'php5-mysql'
  python_package = 'databases/py-MySQLdb'
  ruby_package   = 'ruby-mysql'
else
  case operatingsystem
  when 'Amazon'
    java_package = 'mysql-connector-java'
    perl_package   = 'perl-DBD-MySQL'
    php_package    = 'php5-mysql'
    python_package = 'MySQL-python'
    ruby_package   = 'ruby-mysql'
  end
end

describe 'mysql::bindings class', :unless => UNSUPPORTED_PLATFORMS.include?(fact('operatingsystem')) do

  if fact('osfamily') == 'RedHat' and fact('operatingsystemmajrelease') =~ /(5|6)/
    it 'adds epel' do
      pp = "class { 'epel': }"
      apply_manifest(pp, :catch_failures => true)
    end
  end

  describe 'running puppet code' do
    it 'should work with no errors' do
      pp = <<-EOS
        class { 'mysql::bindings': }
      EOS

      # Run it twice and test for idempotency
      apply_manifest(pp, :catch_failures => true)
      expect(apply_manifest(pp, :catch_failures => true).exit_code).to be_zero
    end
  end

  describe 'all parameters' do
    it 'should work with no errors' do
      pp = <<-EOS
        class { 'mysql::bindings':
          java_enable             => true,
          perl_enable             => true,
          php_enable              => true,
          python_enable           => true,
          ruby_enable             => true,
          java_package_ensure     => present,
          perl_package_ensure     => present,
          php_package_ensure      => present,
          python_package_ensure   => present,
          ruby_package_ensure     => present,
          java_package_name       => #{java_package},
          perl_package_name       => #{perl_package},
          php_package_name        => #{php_package},
          python_package_name     => #{python_package},
          ruby_package_name       => #{ruby_package},
          java_package_provider   => undef,
          perl_package_provider   => undef,
          php_package_provider    => undef,
          python_package_provider => undef,
          ruby_package_provider   => #{ruby_package_provider},
        }
      EOS

      # Run it twice and test for idempotency
      apply_manifest(pp, :catch_failures => true)
      expect(apply_manifest(pp, :catch_failures => true).exit_code).to be_zero
    end

    describe package(java_package) do
      it { should be_installed }
    end

    describe package(perl_package) do
      it { should be_installed }
    end

    # This package is not available out of the box and adding in other repos
    # is a bit much for the scope of this test.
    unless fact('osfamily') == 'RedHat'
      describe package(php_package) do
        it { should be_installed }
      end
    end

    describe package(python_package) do
      it { should be_installed }
    end

    # ruby-mysql is installed via gem on RHEL7, be_installed doesn't know how to check that
    if fact('osfamily') == 'RedHat' && fact('operatingsystemmajrelease') == '7'
      describe package(ruby_package) do
        it { should_not be_installed }
      end
    else
      describe package(ruby_package) do
        it { should be_installed }
      end
    end
  end
end
