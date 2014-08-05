tag = $(shell git describe)
export_name = phpservermon-$(tag)

help:
	@echo ' PHP Server Monitor       - $(tag) '
	@echo ' - make export [tag=...]  - create a new release from tag '
	@echo ' - make install           - install all dependencies '

install:
	@echo 'Downloading dependencies using Composer'
	php composer.phar install
	@echo 'Install complete '

export:
	@echo 'Building release for tag $(tag) '
	mkdir -p ./build ./build/$(export_name)
	rm -rf ./build/$(export_name)/*
	git archive $(tag) | tar -xf - -C ./build/$(export_name)/
	find ./build/$(export_name) -name "*.php" -exec sed -i "" "s/@package_version@/$(tag)/" {} \;
	@echo 'Testing on syntax errors (thats all the automated testing your are going to get for now..) '
	find ./build/$(export_name) -name "*.php" | xargs -I file php -l file
	@echo 'Downloading dependencies'
	cd ./build/$(export_name); php composer.phar install; cd ../../;
	rm -f ./build/$(export_name)/composer.phar
	rm -f ./build/$(export_name)/composer.json
	rm -f ./build/$(export_name)/composer.lock
	@echo 'Building HTML documentation'
	cd ./build/$(export_name)/docs; make BUILDDIR=. html; cd ../../../;
	@echo 'Cleaning up docs dir'
	rm -f ./build/$(export_name)/Makefile
	rm -f ./build/$(export_name)/docs/Makefile
	rm -f ./build/$(export_name)/docs/make.bat
	rm -f ./build/$(export_name)/docs/conf.py
	@echo 'Setting folder and file permissions'
	find ./build/$(export_name) -type f | xargs chmod 0644
	find ./build/$(export_name) -type d | xargs chmod 0755
	@echo 'Creating archives'
	cd ./build; zip -rq $(export_name).zip ./$(export_name); cd ../;
	cd ./build; tar -pczf $(export_name).tar.gz ./$(export_name); cd ../;
	#rm -rf ./build/$(export_name)
	@echo 'Building release finished '
