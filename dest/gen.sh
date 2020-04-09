#!/bin/bash
cd "${0}.d/.."
pwd
function getdir(){
    for element in `ls $1`
    do  
        dir_or_file=$1"/"$element
        if [ -d $dir_or_file ]
        then 
            getdir $dir_or_file
        else
            echo $dir_or_file
        fi  
    done
}


root_dir="."
# blacklist=(./header.php ./footer.php ./gen.sh)
rm -r ../dest/*
for i in $(getdir $root_dir)
do
#	echo ${blacklist[@]}|grep $i -q && continue
	php=false
	echo $i|grep .php -q && php=true
	j=${i#.}
	k=${j%.*}
	if $php; then
		l=../dest${k}.html
	else
		l=../dest${j}
	fi
	m=${l%/*}
	mkdir -p $m
	if $php ;then
		echo -e "\033[33mProceeding PHP:\033[0m" $i $m $l
		php $i>$l
	else
		echo -e "\033[32mCopying File:\033[0m" $i $m $l
		cp $i $l
	fi
done
echo -e "\033[42m\033[37m\033[1mDone!\033[0m"

