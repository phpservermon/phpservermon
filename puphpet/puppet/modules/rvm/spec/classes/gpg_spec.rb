require 'spec_helper'

describe 'rvm::gpg' do

  context "RedHat", :compile do
    let(:facts) {{
      :osfamily => 'RedHat'
    }}
    it { should contain_package('gnupg2') }
  end

  context "Debian", :compile do
    let(:facts) {{
      :osfamily => 'Debian'
    }}
    it { should contain_package('gnupg2') }
  end

  context "OS X", :compile do
    let(:facts) {{
      :osfamily => 'Darwin'
    }}
    it { should_not contain_package('gnupg2') }
  end
end
