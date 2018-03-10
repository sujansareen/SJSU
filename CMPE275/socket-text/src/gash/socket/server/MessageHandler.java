package gash.socket.server;


public interface MessageHandler {
	void process(byte[] msg,int len);
	void addListener(MessageListener listener);
}
