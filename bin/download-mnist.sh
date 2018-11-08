#!/bin/bash
echo "Start download MNIST dataset"
wget --directory-prefix=data http://yann.lecun.com/exdb/mnist/train-images-idx3-ubyte.gz
gzip -d data/train-images-idx3-ubyte.gz

wget --directory-prefix=data http://yann.lecun.com/exdb/mnist/train-labels-idx1-ubyte.gz
gzip -d data/train-labels-idx1-ubyte.gz

wget --directory-prefix=data http://yann.lecun.com/exdb/mnist/t10k-images-idx3-ubyte.gz
gzip -d data/t10k-images-idx3-ubyte.gz

wget --directory-prefix=data http://yann.lecun.com/exdb/mnist/t10k-labels-idx1-ubyte.gz
gzip -d data/t10k-labels-idx1-ubyte.gz
echo "Downloaded MNIST dataset to data/ dir"
