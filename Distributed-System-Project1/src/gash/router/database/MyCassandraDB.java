package gash.router.database;

import java.io.IOException;
import java.nio.ByteBuffer;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.UUID;

public class MyCassandraDB implements DatabaseClient{

	
//	Cluster cluster;
//	Session session;
	
	public MyCassandraDB(String url, String db) {
	//	cluster = Cluster.builder().addContactPoint(url).build();
	//	session = cluster.connect("db275");
	}
	
	
	@Override
	public byte[] get(String key) {
		Statement stmt = null;
		byte[] image = null;
		ByteBuffer img = null;
		byte[] temp = null;
		try {/** TODO: Group */
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
		}
		
		return temp;	
	}

	@Override
	public String post(byte[] image, long timestamp) {
		String key = UUID.randomUUID().toString();
		try {
			System.out.write(image);
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		ByteBuffer img= ByteBuffer.wrap(image);
		/** TODO: Group */
		return key;
	}

	@Override
	public void put(String key, byte[] image, long timestamp) {
		//PreparedStatement ps = null;
		try {/** TODO: Group */
			
		} finally {
		}
		
	}

	@Override
	public void delete(String key) {
		Statement stmt = null;
		try {/** TODO: Group */
			
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			// initiate new everytime
		}
	}
		
	

	@Override
	public long getCurrentTimeStamp() {
		long timestamp = 0; 
		try {
			/** TODO: Group */
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
		}
		return timestamp;	
	}

	@Override
	public List<Record> getNewEntries(long staleTimestamp) {
		List<Record> list = new ArrayList<Record>();
		/** TODO: Group */
				return list;
	}

	@Override
	public void putEntries(List<Record> list) {
		for (Record record : list) {
			put(record.getKey(), record.getImage(), record.getTimestamp());
		}
	}

	@Override
	public List<Record> getAllEntries() {
		List<Record> list = new ArrayList<Record>();
		try {
			/** TODO: Group */
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
		}
		return list;	
	}

	@Override
	public void post(String key, byte[] image, long timestamp) {
	/** TODO: Group */
	}

}
