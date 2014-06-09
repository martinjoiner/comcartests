<cfscript>

absoluteVariable = new http(url='http://www.google.co.uk/');
result = absoluteVariable.send().getPrefix();
writeDump(result); 


    thread
        name='loadURL'
    {
        thread.req = new http();
        thread.req.setUrl( 'http://www.google.co.uk' );
        thread.res = thread.req.send().getPrefix();
    }

    threadJoin( 'loadURL', 3000 );

    if( loadURL.status == 'RUNNING' ) {
        writeOutput( 'Page timed out');
        writeDump( loadURL );
    } else {
        writeOutput('Totes amazeballs');
        writeDump( ToString(loadURL.res.filecontent) );
    } 

</cfscript>

