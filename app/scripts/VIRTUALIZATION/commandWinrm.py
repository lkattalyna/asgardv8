import winrm
import json
import sys
import datetime
#import sqlite3
output = {
    'start': str(datetime.datetime.now()),
    'servers': {}
}

#def ExecuteSQL(con, query):
    # Se crea Cursor para ejecutar sentencias SQL
#    cursorObj = con.cursor()

#    cursorObj.execute(query)
#    con.commit()
#    return cursorObj.lastrowid

#def ConnectionBD():
#    try:
#        con = sqlite3.connect('C:/Users/juan.DESKTOP-R723AS9/Desktop/CommandInterface/engine/database/command.db')
#        return con
#    except:
#        e = sys.exc_info()[1]
#        print(e)
#        raise


def converOutputCommandArray(output):
    data = []
    for outputCommand in str(output).replace('\\n','\n').replace('\\r','').replace("b'","").replace("'","").split('\n'):
        data.append(outputCommand)
    return data

def Get_Connection(Connection, State, Command):
    global output
    dataResult = {
        'server': str(Connection[0]).split('/')[2].split(':')[0],
        'start': str(datetime.datetime.now()),
        'stdout': [],
        'stderr': []
    }
    
    try:
        session = winrm.Session(Connection[0], auth=(Connection[1],Connection[2]), server_cert_validation='ignore')
        result = session.run_ps(Command)
        #print(converOutputCommandArray(result.std_out))
        dataResult['stdout'].append(converOutputCommandArray(result.std_out))
        #print(str(result.std_out).replace('\\n','\n').replace('\\r','\r').replace("b'","").replace("'",""))
        #print(stdout)
        dataResult.setdefault('state', True)
    except:
        e = sys.exc_info()[1]
        dataResult['stderr'].append(str(e).replace("'",""))
        dataResult.setdefault('state', False)
    finally:
        end = str(datetime.datetime.now())
        dataResult.setdefault('end', end)
        output['servers'].setdefault(str(Connection[0]).split('/')[2].split(':')[0], dataResult)


def Get_Parameters(Host, Command):
    User_Remote = 'ansible'
    Pass_Remote = 'jquintero05'
    Port_Remote = '5985'
    IPTS = []
    if Host == '':
        print ('No se ingresaron datos de conexion...')
    else:
        Server_H = (str(Host).split(','))
        for Size_S in range(0,len(Server_H)):
            State = ''
            Size_Real = Size_S + 1
            if Size_Real == len(Server_H):
                State = 'End'
            else:
                State = 'Start'
            Connection = [f'http://{Server_H[Size_S]}:{Port_Remote}/wsman', User_Remote, Pass_Remote, Port_Remote]
            Get_Connection(Connection, State, Command)
        end = str(datetime.datetime.now())
        output.setdefault('end', end)
        print(output)
        #id_output = ExecuteSQL(connectionSQL, f"INSERT INTO outputCommand (command, output) VALUES ('{Command}', '{json.dumps(output)}')")
        #print(id_output)

def GetArgs():
    Host_Remote = ""
    Command = ""
    if len(sys.argv) > 1:
        for arg in sys.argv[1:]:
            
            #------ Valida si tiene el simbolo '=' ------
            if arg.find('=') == -1:
                print ('No se Ingresaron datos en el argumento: ', arg)
            else:
                Split_Argv = arg.split('=')

            #------ Valida si hay contenido despues del simbolo '=' ------
            if Split_Argv[0] == '--IPS':
                if Split_Argv[1] == "":
                    print ("No se Ingreso la IP a la que se quiere conectar... Validar el argumento: " + Split_Argv[0])
                else:
                    Host_Remote = Split_Argv[1]
            
            #------ Valida si hay contenido despues del simbolo '=' ------
            if Split_Argv[0] == '--command':
                if Split_Argv[1] == "":
                    print ("No se Ingreso el comando a ejecutar... Validar el argumento: " + Split_Argv[0])
                else:
                    Command = Split_Argv[1]
        if Host_Remote != "" and Command != "":
            Get_Parameters(Host_Remote, Command)
        else:
            print ('No se ingresaron argumentos. Se requiere usar los siguientes Argumentos: ')
            print ('--IPS=IP_Server0,IP_Server1\n--command=hostname')
    else:
        print ('No se ingresaron argumentos. Se requiere usar los siguientes Argumentos: ')
        print ('--IPS=IP_Server0,IP_Server1\n--command=hostname')

if __name__ == '__main__':
    #con = ConnectionBD()
    #ExecuteSQL(con, "CREATE TABLE IF NOT EXISTS outputCommand (id integer PRIMARY KEY, command text, output text)")
    GetArgs()
else:
    print('Ejecucion Cancelada.')