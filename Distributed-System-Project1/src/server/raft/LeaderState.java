package server.raft;

import java.util.List;

import database.DatabaseService;
import database.Record;
import logger.Logger;
import server.edges.EdgeInfo;
import io.netty.channel.ChannelFuture;
import pipe.common.Common.Request;
import pipe.common.Common.WriteBody;
import pipe.work.AppendEntriesRPC.AppendEntries.RequestType;

import pipe.work.VoteRPC.ResponseVoteRPC;
import pipe.work.Work.WorkMessage;



public class LeaderState extends State implements Runnable {
    //making it singleton
	private static LeaderState INSTANCE = null;
	Thread heartBt = null;
	private LeaderState() {
		// TODO Auto-generated constructor stub

	}

	public static LeaderState getInstance() {
		if (INSTANCE == null) {
			INSTANCE = new LeaderState();
		}
		return INSTANCE;
	}

	@Override
	public void run() {
		Logger.DEBUG("-----------------------LEADER SERVICE STARTED ----------------------------");
//		NodeState.currentTerm++;
	//	initLatestTimeStampOnUpdate();
		heartBt = new Thread(){
		    public void run(){
				while (running) {
					try {
						Thread.sleep(NodeState.getInstance().getServerState().getConf().getHeartbeatDt());
					} catch (InterruptedException e) {
						e.printStackTrace();
					}
					sendHeartBeat();
				}
		    }
		 };

		heartBt.start();
		//ServerQueueService.getInstance().createQueue();
	}

	private void initLatestTimeStampOnUpdate() {

		//NodeState.setTimeStampOnLatestUpdate(DatabaseService.getInstance().getDb().getCurrentTimeStamp());

	}

	private void sendAppendEntriesPacket(WorkMessage workMessage) {

			for (EdgeInfo ei : NodeState.getInstance().getServerState().getEmon().getOutboundEdges().getMap()
					.values()) {

				if (ei.isActive() && ei.getChannel() != null && ei.getRef() != 0) {

					Logger.DEBUG("Sent AppendEntriesPacket to " + ei.getRef() + "for the key " + workMessage.getAppendEntriesPacket().getAppendEntries().getImageMsg().getKey());

					ChannelFuture cf = ei.getChannel().writeAndFlush(workMessage);
					if (cf.isDone() && !cf.isSuccess()) {
						Logger.DEBUG("failed to send message (AppendEntriesPacket) to server");
					}
				}
			}
	}

	public void handleHeartBeatResponse(WorkMessage wm) {

		long timeStampOnLatestUpdate = wm.getHeartBeatPacket().getHeartBeatResponse().getTimeStampOnLatestUpdate();
		/** TODO: Group */

	}

	@Override
	public WorkMessage handleRequestVoteRPC(WorkMessage workMessage) {
		
		return ServerMessageUtils.prepareResponseVoteRPC(ResponseVoteRPC.IsVoteGranted.NO);
	}
	
	public void handleHeartBeat(WorkMessage wm) {
		Logger.DEBUG("HeartbeatPacket received from leader :" + wm.getHeartBeatPacket().getHeartbeat().getLeaderId());
		//onReceivingHeartBeatPacket();
		WorkMessage heartBeatResponse = ServerMessageUtils.prepareHeartBeatResponse();
		
		for (EdgeInfo ei : NodeState.getInstance().getServerState().getEmon().getOutboundEdges().getMap().values()) {

			if (ei.isActive() && ei.getChannel() != null
					&& ei.getRef() == wm.getHeartBeatPacket().getHeartbeat().getLeaderId()) {
					if(wm.getHeartBeatPacket().getHeartbeat().getTerm()>=NodeState.currentTerm) {
						NodeState.getInstance().setNodeState(NodeState.FOLLOWER);
					}
					/** TODO: Group */
			}
		}

	}

	@Override
	public void sendHeartBeat() {
		for (EdgeInfo ei : NodeState.getInstance().getServerState().getEmon().getOutboundEdges().getMap().values()) {
			if (ei.isActive() && ei.getChannel() != null && ei.getRef() != 0) {
				WorkMessage workMessage = ServerMessageUtils.prepareHeartBeat();
				Logger.DEBUG("Sent HeartBeatPacket to " + ei.getRef());
				ChannelFuture cf = ei.getChannel().writeAndFlush(workMessage);
				if (cf.isDone() && !cf.isSuccess()) {
					Logger.DEBUG("failed to send message (HeartBeatPacket) to server");
				}
			}
		}
	/** TODO: Group */		
	}
	
	public void sendClusterMonitor(String host, int port) {
	/** TODO: Group */
		
	}
	public int countActiveNodes() {
		int count = 0;
		for (EdgeInfo ei : NodeState.getInstance().getServerState().getEmon().getOutboundEdges().getMap()
				.values()) {

			if (ei.isActive() && ei.getChannel() != null) {				
				count++;
				
			}
		}
		return count;
	}
	
	@Override
	public void sendAppendEntries(WriteBody wm) {
		
		for (EdgeInfo ei : NodeState.getInstance().getServerState().getEmon().getOutboundEdges().getMap()
				.values()) {

			if (ei.isActive() && ei.getChannel() != null && ei.getRef()	!= 0) {

				Logger.DEBUG("Sent AppendEntriesPacket to " + ei.getRef());

				ChannelFuture cf = ei.getChannel().writeAndFlush(wm);
				if (cf.isDone() && !cf.isSuccess()) {
					Logger.DEBUG("failed to send message (AppendEntriesPacket) to server");
				}
			}
		}
		
		
	}
	
	public byte[] handleGetMessage(String key) {
		System.out.println("GET Request Processed by Node: " + NodeState.getInstance().getServerState().getConf().getNodeId());
		NodeState.updateTaskCount();
		return DatabaseService.getInstance().getDb().get(key);
	}
	
	public String handlePostMessage(byte[] image, long timestamp) {
		System.out.println("POST Request Processed by Node: " + NodeState.getInstance().getServerState().getConf().getNodeId());
		NodeState.updateTaskCount();
		NodeState.setTimeStampOnLatestUpdate(timestamp);
		String key = DatabaseService.getInstance().getDb().post(image, timestamp);
		WorkMessage wm = ServerMessageUtils.prepareAppendEntriesPacket(key, image, timestamp, RequestType.POST);
		sendAppendEntriesPacket(wm);
		return key;
	}
	
	
	public void handleWriteFile(WriteBody msg) {
		System.out.println("POST Request Processed by Node: " + NodeState.getInstance().getServerState().getConf().getNodeId());
		Logger.DEBUG("Data for File : "+msg.getFilename());
		Logger.DEBUG("Data : "+msg.getChunk().getChunkData().toStringUtf8());
		NodeState.updateTaskCount();
		//NodeState.setTimeStampOnLatestUpdate(timestamp);
	//	String key = DatabaseService.getInstance().getDb().post(image, timestamp);
	
	//	sendAppendEntries(msg);
		
	}


	public void handlePutMessage(String key, byte[] image, long timestamp) {
		System.out.println("PUT Request Processed by Node: " + NodeState.getInstance().getServerState().getConf().getNodeId());
		NodeState.updateTaskCount();
		NodeState.setTimeStampOnLatestUpdate(timestamp);
		DatabaseService.getInstance().getDb().put(key, image, timestamp);
		WorkMessage wm = ServerMessageUtils.prepareAppendEntriesPacket(key, image, timestamp, RequestType.PUT);
		sendAppendEntriesPacket(wm);
	}
	
	@Override
	public void handleDelete(String key) {
		System.out.println("DELETE Request Processed by Node: " + NodeState.getInstance().getServerState().getConf().getNodeId());
		NodeState.updateTaskCount();
		NodeState.setTimeStampOnLatestUpdate(System.currentTimeMillis());
		DatabaseService.getInstance().getDb().delete(key);
		WorkMessage wm = ServerMessageUtils.prepareAppendEntriesPacket(key, null, 0 ,RequestType.DELETE);
		sendAppendEntriesPacket(wm);
	}	

	public void startService(State state) {
		running = Boolean.TRUE;
		cthread = new Thread((LeaderState) state);
		cthread.start();
	}

	public void stopService() {
		running = Boolean.FALSE;
		if (cthread != null) {
            try {
                cthread.join();
            } catch (InterruptedException e) {
                Logger.DEBUG("Exception", e);
            }
            Logger.DEBUG("cthread successfully stopped.");
        } 
	}

}
