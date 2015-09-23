#!/bin/sh

# Assign list of GIT tracked files to an array
lstfiles=$(git status --porcelain | sed s/^...//)

# Set field separator to new line character
IFS=$'\n'

# Print an introduction line in cyan
echo "\033[0;36mLinting your changes for non-standard code\033[0m"

# Loop over the file names
for i in $lstfiles
do
  # Print file name eg "text.txt"
  printf "${i} "

  # Count number of lines with the tab characters at the start 
  numtabs=$( egrep "^\t" $i | wc -l )

  # Check if the tab characters has been used 
  numoddspaceindents=$(egrep "^(  )* {1}[^ ]+" $i | wc -l )

  # Total up the errors
  totalerrors=$((numtabs + numoddspaceindents))

  # Print the coloured [failed] or [success] report with new line feed at end
  if [ $totalerrors -gt 0 ]
  then
    printf "\033[0;31m[failed]\n"
  else
    printf "\033[0;32m[passed]\n"
  fi

  # Print report line about tab character being used
  if [ $numtabs -gt 0 ]
  then
    printf "${numtabs} lines indented with a tab character\n"
  fi

  # Print report line about indenting with an odd number of spaces 
  if [ $numoddspaceindents -gt 0 ]
  then
    printf "${numoddspaceindents} lines indented using an odd number of spaces\n"
  fi

  # Reset print color back to default for the next iteration
  printf "\033[0m"

done
unset IFS

