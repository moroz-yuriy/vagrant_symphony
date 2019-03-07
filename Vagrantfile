Vagrant.configure("2") do |config|
  config.vm.box = "chrislentz/trusty64-lamp"
  config.vm.box_version = "1.0.0"
  config.vm.network :private_network, ip: '192.168.50.50'

  forward_port = ->(guest, host = guest) do
    config.vm.network :forwarded_port,
      guest: guest,
      host: host,
      auto_correct: true
  end

  #macOS, Linux
  #config.vm.synced_folder ".", "/var/www", :nfs => true, type: 'nfs', mount_options: ['rw', 'vers=3', 'tcp', 'fsc', 'actimeo=2']

  #Windows
  config.vm.synced_folder ".", "/var/www/html", :owner=> 'www-data', :group=>'www-data', :mount_options => ['dmode=775', 'fmode=775']

  forward_port[3306]      # mysql
  forward_port[80, 8080]  # apache

  config.vm.provision "shell", inline: <<-SHELL
    ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
    /etc/init.d/apache2 restart
  SHELL
end