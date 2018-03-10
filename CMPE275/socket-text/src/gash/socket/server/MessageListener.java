package gash.socket.server;

import gash.socket.data.Message;

public interface MessageListener {
	void onMessage(Message msg);
}
