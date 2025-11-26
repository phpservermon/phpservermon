tag = $(shell git describe)
VERSION = ${subst v,,$(tag)}
RELEASE_DIR = ./build
RELEASE_FILE = phpservermon-$(VERSION)
os = l

help:
	@echo ' PHP Server Monitor - $(tag)'
	@echo ' - make export [os=...] [tag=...]  - create a new release from tag. OS: Use m for macOS.'
	@echo ' - make install           - install all dependencies '

install:
	@echo 'Downloading dependencies using Composer'
	php composer.phar install
	@echo 'Install complete '

export:
	@echo 'Building release for tag $(tag) '
	mkdir -p $(RELEASE_DIR) $(RELEASE_DIR)/$(RELEASE_FILE)
	rm -rf $(RELEASE_DIR)/$(RELEASE_FILE)/*
	git archive $(tag) | tar -xf - -C $(RELEASE_DIR)/$(RELEASE_FILE)/
ifeq (${os}, m)
	find $(RELEASE_DIR)/$(RELEASE_FILE) -name "*.php" -exec sed -i "" "s/@package_version@/$(tag)/" {} \; # for osx
else 
ifeq (${os}, l)
	find $(RELEASE_DIR)/$(RELEASE_FILE) -name "*.php" -exec sed -i "s/@package_version@/$(tag)/" {} \; # for linux
else
	$(error OS invalid, use m for macOS and l for Linux)
endif
endif
	@echo 'Testing on syntax errors (thats all the automated testing your are going to get for now..) '
	find $(RELEASE_DIR)/$(RELEASE_FILE) -name "*.php" | xargs -I file php -l file
	@echo 'Downloading dependencies'
	cd $(RELEASE_DIR)/$(RELEASE_FILE); php composer.phar install; php composer.phar dump-autoload --optimize; cd ../../;
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/composer.phar
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/composer.json
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/composer.lock
	@echo 'Building HTML documentation using sphinx (http://sphinx-doc.org/)'
	mkdir -p $(RELEASE_DIR)/$(RELEASE_FILE)/docs/html
	cd $(RELEASE_DIR)/$(RELEASE_FILE)/docs; make BUILDDIR=. html; cd ../../../;
	@echo 'Cleaning up docs dir'
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/Makefile
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/docs/Makefile
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/docs/make.bat
	rm -f $(RELEASE_DIR)/$(RELEASE_FILE)/docs/conf.py
	@echo 'Setting folder and file permissions'
	find $(RELEASE_DIR)/$(RELEASE_FILE) -type f | xargs chmod 0644
	find $(RELEASE_DIR)/$(RELEASE_FILE) -type d | xargs chmod 0755
	@echo 'Creating archives'
	cd $(RELEASE_DIR); zip -rq $(RELEASE_FILE).zip ./$(RELEASE_FILE); cd ../;
	cd $(RELEASE_DIR); tar -pczf $(RELEASE_FILE).tar.gz ./$(RELEASE_FILE); cd ../;
	#rm -rf $(RELEASE_DIR)/$(RELEASE_FILE)
	@echo 'Building release finished '
