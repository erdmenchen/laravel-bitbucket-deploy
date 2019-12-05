# laravel-bitbucket-deploy
Deploy your laravel app via bitbucket pipelines and envoyer.

> **Important:**
> Be sure, that your project (migrations!) is working as expected (tests!), because there is no backup mechanism during the deployment! 
> Do not deploy to production only, always test releases on staging before!

## Installation
You can easily install this package using Composer by running the following command:
```bash
composer require erdmenchen/laravel-bitbucket-deploy
```

After installation completed run the following command in order to install all required assets:
```bash
php artisan vendor:publish
```

## Bitbucket Configuration
In order to get the build and deployment pipeline going at Bitbucket, you need to make the following steps on Bitbucket:
1. Enable Pipelines
2. Add the repository variables: `DEPLOY_HOST` and `DEPLOY_USER`
3. Create a new SSH key, add your host to the known hosts and copy the public key to your hosting
4. Create the following deployment environments and set the variable `DEPLOY_PATH` for each:
    * Staging
    * Production

## Hosting Configuration
The deployment script requires the following folder structure on the web hosting in order to work:
* Deployment Target Folder
    ** .env (Laravel environment config file)
    ** releases (each deployment will be placed here by the script in unique folders)
    ** storage (Laravel storage folder)

During each deployment, the `.env` file and the `storage` folder are referenced into the current build folder via symlinks.
Additionally a symlink `current` will be created (or updated) in the deployment folder, which points to the latest build folder.

To always point the webserver to the latest release, just create a symlink, that points on the `current` symlink.

## Requirements
This package has the following requirements:

- PHP 7.3 or higher
- Laravel 6.0 or higher

## License
The GNU General Public License v3.0. Please see [License File](LICENSE) for more information.
