
PKG="blogging-theme"

default: compile

compile:
	@grunt build
	
dev:
	@grunt build && grunt watch
	
build:
	@echo "* Initializing build"; rm -Rf build; mkdir -p build
	@echo "* Building assets"; grunt build > /dev/null
	@echo "* Copying assets"; rsync -a . build/ --exclude-from=excludes.rsync
	@echo "* Integrity check"; node tools/buildtool.js --check --path build/
	@echo "* Zipping"; mv build ${PKG}; mkdir build; zip -mqr build/${PKG}.zip ${PKG}; cd build/; unzip -qq ${PKG}.zip

.PHONY: build