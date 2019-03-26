# PHP-ML - Machine Learning library for PHP - Examples

Examples of the use of PHP-ML library

## Projects

Interesting demo/examples projects using `php-ml`:

* [Code Review Estimator](https://github.com/akondas/code-review-estimator) - Simple showcase of machine learning for code review cost estimation.

## Articles

Many of samples from this repository was used in my articles

 * [Text data classification with BBC news article dataset](https://arkadiuszkondas.com/text-data-classification-with-bbc-news-article-dataset/)
 * [Clustering Chicago robberies locations with k-means algorithm](https://arkadiuszkondas.com/clustering-chicago-robberies-locations-with-k-means-algorithm/)
 * [Predict air pollution with k-Nearest Neighbors and PHP](https://arkadiuszkondas.com/predict-air-pollution-with-k-nearest-neighbors-and-php/)

## Examples

To test example, select one of the following and run it from main folder (each category has its own folder).

```
php classification/languageDetection.php
```

Classification:

* `languageDetection.php` - classifier build for language detection
* `minst.php` - recognize handwritten digits from MNIST dataset (to download dataset use `bin/download-mnist.sh`)
* `spamFilter.php` - simple spam filter with example dataset
* `bbc.php` - example of text classification

Regression:

* `wineQuality.php` - regression model to assess the quality of the wine 

## License

PHP-ML is released under the MIT Licence. See the bundled LICENSE file for details.

## Author

Arkadiusz Kondas (@ArkadiuszKondas)
