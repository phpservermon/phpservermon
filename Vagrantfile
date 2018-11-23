# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  # uses ubuntu 18.04 bionic beaver
  config.vm.box = "ubuntu/bionic64"

  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.synced_folder ".", "/vagrant"
  config.vm.provision "shell", path: "Vagrant-bootstrap.sh"
end
