
default: build

build:
	@asset-manager -c .
	
dev:
	@asset-manager .

.PHONY: build