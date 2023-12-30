# Changelog

## [0.3.9](https://github.com/devuri/wpenv-console/compare/v0.3.8...v0.3.9) (2023-12-30)


### Bug Fixes

* update `publickeys` is now `pubkey` ([71e30dc](https://github.com/devuri/wpenv-console/commit/71e30dc55667851a2e4c12a978bf0291bfd00205))


### Miscellaneous Chores

* build ([69bfcbb](https://github.com/devuri/wpenv-console/commit/69bfcbba0c8bdf4ae3f4be95bcb02497d0f8e22c))

## [0.3.8](https://github.com/devuri/wpenv-console/compare/v0.3.7...v0.3.8) (2023-12-25)


### Features

* adds  `generate_random_port()` port number 5000 and 5100 range. ([1115492](https://github.com/devuri/wpenv-console/commit/1115492d1e709987c3d72c162728e0accbd1311d))


### Bug Fixes

* build and composer update  CVE-2023-51651 aws/aws-sdk-php ([4550610](https://github.com/devuri/wpenv-console/commit/45506104473f5f33b1bd26117a2476854a0ff946))


### Miscellaneous Chores

* build ([f1966ca](https://github.com/devuri/wpenv-console/commit/f1966ca108da2ed11281a21cc58fa0ed571c42c9))

## [0.3.7](https://github.com/devuri/wpenv-console/compare/v0.3.6...v0.3.7) (2023-12-10)


### Bug Fixes

* check env loader before we load it, and handle gracefully ([8c4e4a5](https://github.com/devuri/wpenv-console/commit/8c4e4a5050967796351eee088bff25a173b46f18))


### Miscellaneous Chores

* build ([1bb7700](https://github.com/devuri/wpenv-console/commit/1bb7700f01f42f484e2ab2ac27571058a45020e4))

## [0.3.6](https://github.com/devuri/wpenv-console/compare/v0.3.5...v0.3.6) (2023-12-08)


### Bug Fixes

* fix env file loading order ([b0e9777](https://github.com/devuri/wpenv-console/commit/b0e97772eb2c4eeff5dac1956bd5ad28ed2effa2))

## [0.3.5](https://github.com/devuri/wpenv-console/compare/v0.3.4...v0.3.5) (2023-11-09)


### Bug Fixes

* load env vars from trait ([c9b243c](https://github.com/devuri/wpenv-console/commit/c9b243c2d1d80cf222e8c2367a4a52fee3363fc8))


### Miscellaneous Chores

* build ([bb455a2](https://github.com/devuri/wpenv-console/commit/bb455a2cb3739d4b9df8947f7a2974d1dfef818d))
* docs build ([7550005](https://github.com/devuri/wpenv-console/commit/755000598ca648167e78091eeb4fe908a9f298fe))

## [0.3.4](https://github.com/devuri/wpenv-console/compare/v0.3.3...v0.3.4) (2023-11-08)


### Bug Fixes

* fix env files also can ow use all files without `dot` ([55f030f](https://github.com/devuri/wpenv-console/commit/55f030fb811e30a33525cbaf11b8c4e016c68c35))

## [0.3.3](https://github.com/devuri/wpenv-console/compare/v0.3.2...v0.3.3) (2023-11-02)


### Bug Fixes

* make sure `ZipArchive` is available ([18bdec0](https://github.com/devuri/wpenv-console/commit/18bdec08a6f491013e29cff5ca3fe554a9b1b587))
* update env file output ([b2c9937](https://github.com/devuri/wpenv-console/commit/b2c9937a1cbefaa34bb9c3097e61f81dfdadd9d3))


### Miscellaneous Chores

* build ([118a7ed](https://github.com/devuri/wpenv-console/commit/118a7ed0ef0f9998158b2d7a642d20f68143a62b))
* build ([dd58b77](https://github.com/devuri/wpenv-console/commit/dd58b77f91b4e32a570480cd33bb6431f3a0588f))

## [0.3.2](https://github.com/devuri/wpenv-console/compare/v0.3.1...v0.3.2) (2023-10-31)


### Bug Fixes

* update use  Urisoft\Filesystem ([5791ac2](https://github.com/devuri/wpenv-console/commit/5791ac219ea3232787c9544c7fb7e4bbd711f3a4))

## [0.3.1](https://github.com/devuri/wpenv-console/compare/v0.3.0...v0.3.1) (2023-10-31)


### Bug Fixes

* update use Urisoft\Filesystem ([5e335a4](https://github.com/devuri/wpenv-console/commit/5e335a48969d593701de8f76509209c3ef71bc52))

## [0.3.0](https://github.com/devuri/wpenv-console/compare/v0.2.1...v0.3.0) (2023-10-31)


### ⚠ BREAKING CHANGES

* upgrade to 0.3 `devuri/encryption`

### Bug Fixes

* upgrade to 0.3 `devuri/encryption` ([ccc6421](https://github.com/devuri/wpenv-console/commit/ccc642189f3d915e8238c45589d2303b78ae56bb))


### Miscellaneous Chores

* build ([44542d1](https://github.com/devuri/wpenv-console/commit/44542d1ac1dffc61edd505a1c3415f4fe18c4acd))

## [0.2.1](https://github.com/devuri/wpenv-console/compare/v0.2.0...v0.2.1) (2023-10-27)


### Features

* can now generate `.secret` file on `setup` command ([f010ebc](https://github.com/devuri/wpenv-console/commit/f010ebcce349e962db8585f16c6f8a7eed3eb3a3))

## [0.2.0](https://github.com/devuri/wpenv-console/compare/v0.1.6...v0.2.0) (2023-10-23)


### ⚠ BREAKING CHANGES

* creates .env file with `setup` command

### Features

* creates .env file with `setup` command ([51d785e](https://github.com/devuri/wpenv-console/commit/51d785e8b3c5d32acd8a9cbb32d8380a44332a80))


### Miscellaneous Chores

* build ([68bfd81](https://github.com/devuri/wpenv-console/commit/68bfd81488ae6611510d113ed6e99829131e6aac))
* build ([87210a3](https://github.com/devuri/wpenv-console/commit/87210a3ad57bd1c15221b3246349bb95d04300aa))

## [0.1.6](https://github.com/devuri/wpenv-console/compare/v0.1.5...v0.1.6) (2023-09-24)


### Bug Fixes

* fix the port when not set in .env file ([02037c9](https://github.com/devuri/wpenv-console/commit/02037c99f12e4df1a3f8e397698bef25d9ab5dee))

## [0.1.5](https://github.com/devuri/wpenv-console/compare/v0.1.4...v0.1.5) (2023-09-24)


### Bug Fixes

* fix Env files property, same property ($files) ([c06ca68](https://github.com/devuri/wpenv-console/commit/c06ca68197980c90a3757f01aa0bf6216e03270f))

## [0.1.4](https://github.com/devuri/wpenv-console/compare/v0.1.3...v0.1.4) (2023-09-23)


### Bug Fixes

* the `ssl` command is now `wp:ssl` ([16d3e01](https://github.com/devuri/wpenv-console/commit/16d3e012f84528e0faa7b9acf05e632d9b407967))

## [0.1.3](https://github.com/devuri/wpenv-console/compare/v0.1.2...v0.1.3) (2023-09-23)


### Bug Fixes

* cli fixes ([4854442](https://github.com/devuri/wpenv-console/commit/485444212d21decd11b0a986c5c92b6180409eda))
* fix .env in login command ([11a1cbb](https://github.com/devuri/wpenv-console/commit/11a1cbb2205d76e275af921809d86cb4a8c772dd))

## [0.1.2](https://github.com/devuri/wpenv-console/compare/v0.1.1...v0.1.2) (2023-09-23)


### Features

* adds docs ([c8021b9](https://github.com/devuri/wpenv-console/commit/c8021b922f5577e9e3e855e97145cdaa22394410))
