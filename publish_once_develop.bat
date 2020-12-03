:: Auto Updater on github
echo %date% %time%
git add .
git commit -m "I did it https://github.com/dmd2222 on %date% at %time%"
git branch develop
git push -u origin develop
pause