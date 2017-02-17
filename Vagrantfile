VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  if defined?(VagrantVbguest::Middleware)
    config.vbguest.auto_update = true
  end

  config.vm.box = "ubuntu/trusty64"
  config.vm.provision "shell", path: 'vagrant/provision.sh'

  config.vm.define 'gold-prices' do |node|
    node.vm.hostname = 'gold-prices.local'
    node.vm.network :private_network, ip: '192.168.11.11'
  end

  config.vm.provider :virtualbox do |vb|
    vb.customize ["modifyvm", :id, "--cpus", "2", "--memory", "2048"]
  end

  config.vm.synced_folder "./", "/vagrant", type: "nfs",  mount_options: ['rw', 'vers=3', 'tcp', 'fsc' ,'actimeo=2']

  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
end
