# This function is called inside the OS specific contexts
def general_info_specs
  it { is_expected.to contain_apache__mod('info') }

  context 'passing no parameters' do
    it {
      is_expected.to contain_file('info.conf').with_content(
        "<Location /server-info>\n"\
        "    SetHandler server-info\n"\
        "    Order deny,allow\n"\
        "    Deny from all\n"\
        "    Allow from 127.0.0.1\n"\
        "    Allow from ::1\n"\
        "</Location>\n"
      )
    }
  end
  context 'passing restrict_access => false' do
    let :params do {
      :restrict_access => false
    }
    end
    it {
      is_expected.to contain_file('info.conf').with_content(
        "<Location /server-info>\n"\
        "    SetHandler server-info\n"\
        "</Location>\n"
      )
    }
  end
  context "passing allow_from => ['10.10.1.2', '192.168.1.2', '127.0.0.1']" do
    let :params do
      {:allow_from => ['10.10.1.2', '192.168.1.2', '127.0.0.1']}
    end
    it {
      is_expected.to contain_file('info.conf').with_content(
        "<Location /server-info>\n"\
        "    SetHandler server-info\n"\
        "    Order deny,allow\n"\
        "    Deny from all\n"\
        "    Allow from 10.10.1.2\n"\
        "    Allow from 192.168.1.2\n"\
        "    Allow from 127.0.0.1\n"\
        "</Location>\n"
      )
    }
  end
  context 'passing both restrict_access and allow_from' do
    let :params do
      {
        :restrict_access => false,
        :allow_from      => ['10.10.1.2', '192.168.1.2', '127.0.0.1']
      }
    end
    it {
      is_expected.to contain_file('info.conf').with_content(
        "<Location /server-info>\n"\
        "    SetHandler server-info\n"\
        "</Location>\n"
      )
    }
  end
end

describe 'apache::mod::info', :type => :class do
  let :pre_condition do
    "class { 'apache': default_mods => false, }"
  end

  context 'On a Debian OS' do
    let :facts do
      {
        :osfamily               => 'Debian',
        :operatingsystemrelease => '6',
        :concat_basedir         => '/dne',
        :lsbdistcodename        => 'squeeze',
        :operatingsystem        => 'Debian',
        :id                     => 'root',
        :kernel                 => 'Linux',
        :path                   => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
      }
    end

    # Load the more generic tests for this context
    general_info_specs()

    it { is_expected.to contain_file('info.conf').with({
      :ensure => 'file',
      :path   => '/etc/apache2/mods-available/info.conf',
    } ) }
    it { is_expected.to contain_file('info.conf symlink').with({
      :ensure => 'link',
      :path   => '/etc/apache2/mods-enabled/info.conf',
    } ) }
  end

  context 'on a RedHat OS' do
    let :facts do
      {
        :osfamily               => 'RedHat',
        :operatingsystemrelease => '6',
        :concat_basedir         => '/dne',
        :operatingsystem        => 'RedHat',
        :id                     => 'root',
        :kernel                 => 'Linux',
        :path                   => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
      }
    end

    # Load the more generic tests for this context
    general_info_specs()

    it { is_expected.to contain_file('info.conf').with({
      :ensure => 'file',
      :path   => '/etc/httpd/conf.d/info.conf',
      } ) }
  end

  context 'on a FreeBSD OS' do
    let :facts do
      {
        :osfamily               => 'FreeBSD',
        :operatingsystemrelease => '9',
        :concat_basedir         => '/dne',
        :operatingsystem        => 'FreeBSD',
        :id                     => 'root',
        :kernel                 => 'FreeBSD',
        :path                   => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin',
      }
    end

    # Load the more generic tests for this context
    general_info_specs()

    it { is_expected.to contain_file('info.conf').with({
      :ensure => 'file',
      :path   => '/usr/local/etc/apache22/Modules/info.conf',
    } ) }
  end

end
