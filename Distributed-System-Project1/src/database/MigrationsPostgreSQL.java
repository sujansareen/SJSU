package database;

public class MigrationsPostgreSQL {
    public String createMessageTable(){
        StringBuilder sql = new StringBuilder();
        return sql.append("CREATE TABLE messages ( " +
                " id             varchar PRIMARY KEY CONSTRAINT no_null NOT NULL DEFAULT ('msg_'::text || (substr(md5((random())::text), 1, 4) || (nextval('messages_seq'::regclass))::text)),\n" +
                " message        varchar NOT NULL, " +
                " to_id          varchar CONSTRAINT no_null NOT NULL,\n" +
                " from_id        varchar CONSTRAINT no_null NOT NULL,\n" +
                " created        TIMESTAMP CONSTRAINT no_null NOT NULL DEFAULT now(),\n" +
                " archived       TIMESTAMP\n" +
                ");").toString();
    }
    public String seqMessageTable(){
        StringBuilder sql = new StringBuilder();
        return sql.append("CREATE SEQUENCE messages_seq\n" +
                "                    INCREMENT 1\n" +
                "                    MINVALUE 1000\n" +
                "                    MAXVALUE 999999999\n" +
                "                    START 1001\n" +
                "                    CYCLE\n" +
                "            ;").toString();
    }

}

