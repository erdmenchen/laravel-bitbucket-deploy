# laravel-bitbucket-deploy
Deploy your laravel app via bitbucket pipelines and envoyer.

<p align="center">
    <a href="https://packagist.org/packages/erdmenchen/laravel-bitbucket-deploy"><img src="https://poser.pugx.org/erdmenchen/laravel-bitbucket-deploy/downloads"></a>
    <a href="https://packagist.org/packages/erdmenchen/laravel-bitbucket-deploy"><img src="https://poser.pugx.org/erdmenchen/laravel-bitbucket-deploy/version"></a>
    <a href="https://packagist.org/packages/erdmenchen/laravel-bitbucket-deploy"><img src="https://poser.pugx.org/erdmenchen/laravel-bitbucket-deploy/v/unstable"></a>
    <a href="https://packagist.org/packages/erdmenchen/laravel-bitbucket-deploy"><img src="https://poser.pugx.org/erdmenchen/laravel-bitbucket-deploy/license"></a>
</p>

> **Important:** <br />
> Be sure, that your project (migrations!) is working as expected (tests!), because there is no backup mechanism during the deployment! <br />
> Do not deploy to production only, always test releases on staging before!

## Prerequisites
* Bitbucket account
* Bitbucket Pipeline build minutes available ([the free plan](https://confluence.atlassian.com/bitbucket/plans-and-billing-224395568.html#BitbucketCloudplandetails-Plandetails) has 50min per month)
* Hosting with SSH access

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
In order to get the build and deployment pipeline going at Bitbucket, you need to make the following steps in your Bitbucket repository:
1. Enable Pipelines
2. Add the repository variables: `DEPLOY_HOST` and `DEPLOY_USER`
3. Create a new SSH key, add your host to the known hosts and copy the public key to your hosting
4. Create the following deployment environments and set the variable `DEPLOY_PATH` for each:
    * Staging
    * Production

## Hosting Configuration
The deployment script requires the following folder structure on the web hosting in order to work:
* Deployment Target Folder (e.g. `cool_website_staging`)
    * .env (Laravel environment config file)
    * releases (each deployment will be placed here by the script in unique folders)
    * storage (Laravel storage folder)
        * framework/sessions
        * framework/views
        * framework/cache

During each deployment, the `.env` file and the `storage` folder are referenced into the current build folder via symlinks.
Additionally a symlink `current` will be created (or updated) in the deployment folder, which points to the latest build folder.

To always point the webserver to the latest release, just create a symlink, that points on the `current` symlink (e.g. `cool_website.com` -> `cool_website_staging/current/public`. You don´t need to edit it during deployment. It will always point to the latest release.

## Requirements
This package has the following requirements:
- PHP 7.3 or higher
- Laravel 6.0 or higher

## How it works
This package scaffolds a [Bitbucket pipeline](https://bitbucket.org/product/de/features/pipelines) script and a [Laravel Envoyer](https://laravel.com/docs/master/envoy) script into your Laravel project.

When a new pipeline run is triggered (via git commit or manually) a full CI/CD (Continuous Integration/Continuous Delivery) build is executed with the following steps:

1. Fetch source code and install PHP dependencies (`Build PHP`)
2. Run `phpunit` and gather results - stops on any failed test (`Test PHP`)
3. Install javascript dependencies via npm and build UI assets(`Build Assets`)
4. Deploy to staging / production - connects to hosting via ssh and pushes build (`Deploy`)
    * Create manifest file with original trigger commit details
    * Create symlinks to `.env` and `storage`
    * Check Laravel health (running `php artisan --version`)
    * Activate build by updating the `current` symlink
    * Optimise, migrate and cleanup Laravel project

The last step (step 4) is only executed when triggered from a commit on `develop` or `master` branch. Feature branches are build only, they do not get deployed.

## License
The GNU General Public License v3.0. Please see [License File](LICENSE) for more information.
