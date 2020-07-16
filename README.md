
# Installation

Add the following part to you `composer.json`:

```
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/ventureleap/util.git"
        }
    ]
```

Then, add the bundle to your requirements section in `composer.json`:

```
        "ventureleap/util": "dev-master"
```

Now initialize the bundle by adding it to your `AppKernel.php`:

```
public function registerBundles()
    {
        $bundles = array(
            ...
            new VentureLeapUtilBundle\VentureLeapUtilBundle(),
            ...
        );
        
        ...
    }

```
