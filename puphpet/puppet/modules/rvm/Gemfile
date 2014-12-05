source 'https://rubygems.org'

group :rake do
  gem 'puppet', ENV['PUPPET_VERSION'] || '>=3.0.0', :require => false
  gem 'rspec-puppet', '>=1.0.0', :require => false
  gem 'rake', :require => false
  gem 'puppet-lint', '>=1.0.0', :require => false
  gem 'puppetlabs_spec_helper', :require => false
  gem 'puppet-blacksmith', '>=1.0.5', :require => false
  gem 'librarian-puppet', '>=2.0.0', :require => false
  gem 'beaker', '>=1.14.0', :require => false
  gem 'beaker-rspec', '>=2.1.0', :require => false
  gem 'minitest', '<5.0.0', :require => false # conflicts with beaker
end
