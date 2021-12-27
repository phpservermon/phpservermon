# -*- mode: ruby -*-
# vi: set ft=ruby :

ENV['VAGRANT_DEFAULT_PROVIDER'] = 'virtualbox'
Vagrant.configure("2") do |config|
  ##### VM definition #####
  config.vm.define "phpservermon-dev" do |config|
  config.vm.hostname = "phpservermon-dev"
  config.vm.box = "bento/ubuntu-20.04"
  config.vm.box_check_update = false
  config.vm.network "private_network", ip: "192.168.56.100"
  config.vm.provision :ansible do |ansible|
    ansible.limit = "all"
    ansible.playbook = "provision.yaml"
  end
  config.vm.provider "virtualbox" do |vb|
  vb.memory = "2048"
  vb.cpus = "2"
  end
end
end
