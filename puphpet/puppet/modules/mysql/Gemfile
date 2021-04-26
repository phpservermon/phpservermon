source ENV['GEM_SOURCE'] || 'https://rubygems.org'

group :development, :test do
  gem 'mime-types', '<2.0',      :require => false
  gem 'rake',  '10.1.1',         :require => false
  gem 'rspec', '~> 2.11',        :require => false
  gem 'rspec-puppet',            :require => false
  gem 'puppetlabs_spec_helper',  :require => false
  gem 'serverspec',              :require => false
  gem 'puppet-lint',             :require => false
  gem 'pry',                     :require => false
  gem 'simplecov',               :require => false
  gem 'beaker',                  :require => false
  gem 'beaker-rspec', '>= 2.2',  :require => false
end

if puppetversion = ENV['PUPPET_GEM_VERSION']
  gem 'puppet', puppetversion, :require => false
else
  gem 'puppet', :require => false
end

# vim:ft=ruby
